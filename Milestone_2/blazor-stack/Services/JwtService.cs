using System.IdentityModel.Tokens.Jwt;
using System.Security.Claims;
using System.Text;
using Microsoft.IdentityModel.Tokens;
using PixelPalsBlazor.Models;

namespace PixelPalsBlazor.Services;

public class JwtService
{
    private readonly string secretKey;

    public JwtService(IConfiguration configuration)
    {
        secretKey = configuration["Jwt:Key"]
            ?? throw new InvalidOperationException("JWT key is not configured.");
    }

    // Creates a JWT after the user successfully logs in.
    // The token stores the user's ID and email so the application
    // can identify the authenticated user later.
    public string CreateToken(User user)
    {
        var claims = new[]
        {
            new Claim(ClaimTypes.NameIdentifier, user.Id.ToString()),
            new Claim(ClaimTypes.Email, user.Email)
        };

        var key = new SymmetricSecurityKey(
            Encoding.UTF8.GetBytes(secretKey));

        var credentials = new SigningCredentials(
            key,
            SecurityAlgorithms.HmacSha256);

        var token = new JwtSecurityToken(
            claims: claims,
            expires: DateTime.UtcNow.AddHours(1),
            signingCredentials: credentials);

        return new JwtSecurityTokenHandler().WriteToken(token);
    }

    // Validates a JWT and returns the user ID stored inside it.
    // My Account and Transaction will use this instead of trusting
    // a user ID entered by the user.
    public int? GetUserIdFromToken(string token)
    {
        try
        {
            var tokenHandler = new JwtSecurityTokenHandler();

            var key = Encoding.UTF8.GetBytes(secretKey);

            var principal = tokenHandler.ValidateToken(
                token,
                new TokenValidationParameters
                {
                    ValidateIssuer = false,
                    ValidateAudience = false,
                    ValidateLifetime = true,
                    ValidateIssuerSigningKey = true,
                    IssuerSigningKey = new SymmetricSecurityKey(key),
                    ClockSkew = TimeSpan.Zero
                },
                out _);

            var userId = principal.FindFirst(ClaimTypes.NameIdentifier)?.Value;

            if (int.TryParse(userId, out var id))
            {
                return id;
            }

            return null;
        }
        catch
        {
            return null;
        }
    }
}