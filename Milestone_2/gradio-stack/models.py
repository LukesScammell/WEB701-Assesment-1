from sqlalchemy import Column, Integer, String
from database import Base


# Defines the user information stored in the SQLite database.
class User(Base):
    __tablename__ = "users"

    # Gives each user a unique ID.
    id = Column(Integer, primary_key=True, index=True)

    # Stores the user's account information.
    name = Column(String, nullable=False)
    email = Column(String, unique=True, nullable=False)

    # Will store the user's hashed password.
    password = Column(String, nullable=False)

    # New users will begin with 100 tokens.
    tokens = Column(Integer, default=100)