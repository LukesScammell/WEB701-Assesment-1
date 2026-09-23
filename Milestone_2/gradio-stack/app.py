import gradio as gr
from database import engine, Base
import models


# Creates the database tables when the application starts.
Base.metadata.create_all(bind=engine)


# Creates the basic Gradio interface for the Pixel Pals prototype.
with gr.Blocks(title="Pixel Pals") as app:
    gr.Markdown("# Pixel Pals")
    gr.Markdown("Gradio framework prototype for WEB701.")

    gr.Markdown("## Account System")
    gr.Markdown("Registration and login functionality will be added here.")

    gr.Markdown("## Token Transaction")
    gr.Markdown("Token transaction functionality will be added here.")


# Starts the Gradio application.
if __name__ == "__main__":
    app.launch()