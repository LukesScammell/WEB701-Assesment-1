import gradio as gr
from database import engine, Base, SessionLocal
from models import User
from auth import hash_password
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
    gr.Markdown("Login functionality will be added next.")

    gr.Markdown("## Token Transaction")
    gr.Markdown("Token transaction functionality will be added later.")


# Starts the Gradio application.
if __name__ == "__main__":
    app.launch()