from sqlalchemy import Column, Integer, String
from database import Base


# Requirement 3: This model defines the user information
# that is stored and retrieved from the database.
class User(Base):
    __tablename__ = "users"

    # Gives each user a unique ID in the database.
    id = Column(Integer, primary_key=True, index=True)

    # Stores the user's account information.
    name = Column(String, nullable=False)
    email = Column(String, unique=True, nullable=False)

    # Stores the user's hashed password rather than the plain password.
    password = Column(String, nullable=False)

    # Stores the user's token balance and gives new users 100 tokens.
    tokens = Column(Integer, default=100)