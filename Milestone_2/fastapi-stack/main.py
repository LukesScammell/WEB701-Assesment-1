from fastapi import FastAPI, Depends, HTTPException, Header, Request
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates
from sqlalchemy.orm import Session
from pydantic import BaseModel
import jwt

import models
import auth
from database import engine, get_db


# Creates the database tables defined in models.py.
models.Base.metadata.create_all(bind=engine)


app = FastAPI()


# Makes the CSS and JavaScript files inside the static folder
# available to the frontend.
app.mount("/static", StaticFiles(directory="static"), name="static")


# Tells FastAPI where the HTML templates are stored.
templates = Jinja2Templates(directory="templates")


# Defines the information required when a user registers.
class RegisterRequest(BaseModel):
    name: str
    email: str
    password: str


# Defines the information required when a user logs in.
class LoginRequest(BaseModel):
    email: str
    password: str


# Defines the number of tokens used in a transaction.
class TransactionRequest(BaseModel):
    amount: int


# Displays the HTML frontend for the FastAPI prototype.
@app.get("/")
def home(request: Request):
    return templates.TemplateResponse(
        request=request,
        name="index.html"
    )


# Requirement 1:
# Registers a new user and stores their account in the database.
@app.post("/register")
def register(user: RegisterRequest, db: Session = Depends(get_db)):
    existing_user = db.query(models.User).filter(
        models.User.email == user.email
    ).first()

    # Prevents two accounts from using the same email address.
    if existing_user:
        raise HTTPException(
            status_code=400,
            detail="Email is already registered"
        )

    # Hashes the password before the account is stored.
    new_user = models.User(
        name=user.name,
        email=user.email,
        password=auth.hash_password(user.password)
    )

    db.add(new_user)
    db.commit()
    db.refresh(new_user)

    return {
        "message": "User registered successfully",
        "user_id": new_user.id
    }


# Requirement 1:
# Checks the user's login details and creates a JWT when successful.
@app.post("/login")
def login(user: LoginRequest, db: Session = Depends(get_db)):
    existing_user = db.query(models.User).filter(
        models.User.email == user.email
    ).first()

    if not existing_user:
        raise HTTPException(
            status_code=401,
            detail="Invalid email or password"
        )

    # Compares the entered password with the stored password hash.
    if not auth.verify_password(user.password, existing_user.password):
        raise HTTPException(
            status_code=401,
            detail="Invalid email or password"
        )

    # Creates a JWT containing the authenticated user's ID.
    access_token = auth.create_access_token(existing_user.id)

    return {
        "message": "Login successful",
        "access_token": access_token,
        "token_type": "bearer"
    }


# Requirements 1 and 3:
# Uses the JWT to identify the user and retrieve their stored account data.
@app.get("/account")
def account(
    authorization: str = Header(),
    db: Session = Depends(get_db)
):
    try:
        token = authorization.replace("Bearer ", "")

        # Validates the JWT and retrieves the user ID stored inside it.
        payload = jwt.decode(
            token,
            auth.SECRET_KEY,
            algorithms=[auth.ALGORITHM]
        )

        user_id = payload["user_id"]

    except jwt.InvalidTokenError:
        raise HTTPException(
            status_code=401,
            detail="Invalid or expired token"
        )

    # Retrieves the authenticated user's information from the database.
    user = db.query(models.User).filter(
        models.User.id == user_id
    ).first()

    if not user:
        raise HTTPException(
            status_code=404,
            detail="User not found"
        )

    return {
        "id": user.id,
        "name": user.name,
        "email": user.email,
        "tokens": user.tokens
    }


# Requirement 2:
# Processes a token transaction for an authenticated user.
@app.post("/transaction")
def transaction(
    transaction: TransactionRequest,
    authorization: str = Header(),
    db: Session = Depends(get_db)
):
    try:
        token = authorization.replace("Bearer ", "")

        # The JWT transfers the authenticated user's state to this request.
        payload = jwt.decode(
            token,
            auth.SECRET_KEY,
            algorithms=[auth.ALGORITHM]
        )

        user_id = payload["user_id"]

    except jwt.InvalidTokenError:
        raise HTTPException(
            status_code=401,
            detail="Invalid or expired token"
        )

    # Finds the authenticated user's account in the database.
    user = db.query(models.User).filter(
        models.User.id == user_id
    ).first()

    if not user:
        raise HTTPException(
            status_code=404,
            detail="User not found"
        )

    # Prevents invalid transaction amounts.
    if transaction.amount <= 0:
        raise HTTPException(
            status_code=400,
            detail="Transaction amount must be greater than zero"
        )

    # Prevents the user from spending more tokens than they have.
    if transaction.amount > user.tokens:
        raise HTTPException(
            status_code=400,
            detail="Not enough tokens"
        )

    # Updates the token balance and saves the change to the database.
    user.tokens -= transaction.amount

    db.commit()
    db.refresh(user)

    return {
        "message": "Transaction successful",
        "tokens_used": transaction.amount,
        "remaining_tokens": user.tokens
    }