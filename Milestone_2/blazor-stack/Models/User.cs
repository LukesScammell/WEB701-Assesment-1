namespace PixelPalsBlazor.Models;

// Requirement 3: This model defines the user information
// that will be stored and retrieved from the SQLite database.
public class User
{
    // Gives each user a unique ID in the database.
    public int Id { get; set; }

    // Stores the user's account information.
    public string Name { get; set; } = string.Empty;
    public string Email { get; set; } = string.Empty;

    // Stores the user's hashed password instead of the plain password.
    public string Password { get; set; } = string.Empty;

    // New users begin with 100 tokens.
    public int Tokens { get; set; } = 100;
}