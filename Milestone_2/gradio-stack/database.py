from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker, declarative_base


# SQLite database used by the Gradio prototype.
DATABASE_URL = "sqlite:///./pixelpals.db"

engine = create_engine(
    DATABASE_URL,
    connect_args={"check_same_thread": False}
)

SessionLocal = sessionmaker(
    autocommit=False,
    autoflush=False,
    bind=engine
)

Base = declarative_base()


# Creates a database session when the application needs to access data.
def get_db():
    db = SessionLocal()
    try:
        return db
    except:
        db.close()
        raise