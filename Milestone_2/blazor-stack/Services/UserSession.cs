namespace PixelPalsBlazor.Services;

// Stores the authenticated user's JWT for the current Blazor session.
public class UserSession
{
    public string JwtToken { get; set; } = "";
}