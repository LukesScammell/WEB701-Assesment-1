import bcrypt
import jwt
from datetime import datetime, timedelta, timezone


SECRET_KEY = "pixelpals_gradio_secret"
ALGORITHM = "HS256"


# Hashes a password before it is stored in the database.
def hash_password(password: str):
    password_bytes = password.encode("utf-8")
    salt = bcrypt.gensalt()
    hashed_password = bcrypt.hashpw(password_bytes, salt)
    return hashed_password.decode("utf-8")


# Checks an entered password against the hashed password in the database.
def verify_password(password: str, hashed_password: str):
    password_bytes = password.encode("utf-8")
    hashed_password_bytes = hashed_password.encode("utf-8")
    return bcrypt.checkpw(password_bytes, hashed_password_bytes)


# Creates a JWT for the authenticated user.
def create_access_token(user_id: int):
    expiry = datetime.now(timezone.utc) + timedelta(hours=1)

    token_data = {
        "user_id": user_id,
        "exp": expiry
    }

    return jwt.encode(token_data, SECRET_KEY, algorithm=ALGORITHM)