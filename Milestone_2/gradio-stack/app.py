import gradio as gr
from database import engine, Base, SessionLocal
from models import User
from auth import hash_password, verify_password, create_access_token, decode_access_token
import models


# Creates the database tables when the application starts.
Base.metadata.create_all(bind=engine)


# Registers a new Pixel Pals user.
def register_user(name, email, password):
    # Checks that all registration fields have been entered.
    if not name or not email or not password:
        return "Please complete all registration fields."

    db = SessionLocal()

    try:
        # Checks whether an account already uses this email address.
        existing_user = db.query(User).filter(User.email == email).first()

        if existing_user:
            return "Email is already registered."

        # Hashes the password before storing it in the database.
        hashed_password = hash_password(password)

        # Creates the new user with an initial balance of 100 tokens.
        new_user = User(
            name=name,
            email=email,
            password=hashed_password,
            tokens=100
        )

        db.add(new_user)
        db.commit()

        return "Registration successful."

    finally:
        db.close()
        
# Logs a user in and creates a JWT when the credentials are correct.
def login_user(email, password):
    if not email or not password:
        return "Please enter your email and password.", ""

    db = SessionLocal()

    try:
        # Retrieves the user account using the entered email address.
        user = db.query(User).filter(User.email == email).first()

        if not user:
            return "Invalid email or password.", ""

        # Checks the entered password against the stored password hash.
        if not verify_password(password, user.password):
            return "Invalid email or password.", ""

        # Creates a JWT containing the authenticated user's ID.
        token = create_access_token(user.id)

        return "Login successful.", token

    finally:
        db.close()

# Retrieves the authenticated user's account information.
def get_account(token):
    if not token:
        return "You must log in first."

    # Gets the user ID stored inside the JWT.
    user_id = decode_access_token(token)

    if not user_id:
        return "Invalid or expired login."

    db = SessionLocal()

    try:
        # Retrieves the authenticated user's data from the database.
        user = db.query(User).filter(User.id == user_id).first()

        if not user:
            return "User account could not be found."

        return f"Name: {user.name}\nEmail: {user.email}\nTokens: {user.tokens}"

    finally:
        db.close()

# Creates the Gradio interface for the Pixel Pals prototype.
with gr.Blocks(title="Pixel Pals") as app:
    gr.Markdown("# Pixel Pals")
    gr.Markdown("Gradio framework prototype for WEB701.")

    gr.Markdown("## Register Account")

    register_name = gr.Textbox(label="Name")
    register_email = gr.Textbox(label="Email")
    register_password = gr.Textbox(label="Password", type="password")
    register_button = gr.Button("Register")
    register_output = gr.Textbox(label="Registration Result")

    # Runs the Python registration function when Register is clicked.
    register_button.click(
        fn=register_user,
        inputs=[register_name, register_email, register_password],
        outputs=register_output
    )

    gr.Markdown("## Login")

    login_email = gr.Textbox(label="Email")
    login_password = gr.Textbox(label="Password", type="password")
    login_button = gr.Button("Login")
    login_output = gr.Textbox(label="Login Result")

    # Stores the JWT in the Gradio application state after login.
    jwt_state = gr.State("")

    login_button.click(
        fn=login_user,
        inputs=[login_email, login_password],
        outputs=[login_output, jwt_state]
    )

    gr.Markdown("## My Account")

    account_button = gr.Button("Load Account")
    account_output = gr.Textbox(label="Account Information", lines=3)

    # Uses the JWT from the current Gradio session to retrieve the user's account.
    account_button.click(
        fn=get_account,
        inputs=jwt_state,
        outputs=account_output
    )

    
    gr.Markdown("## Token Transaction")
    gr.Markdown("Token transaction functionality will be added later.")


# Starts the Gradio application.
if __name__ == "__main__":
    app.launch()