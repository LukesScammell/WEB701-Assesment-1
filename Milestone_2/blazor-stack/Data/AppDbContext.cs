using Microsoft.EntityFrameworkCore;
using PixelPalsBlazor.Models;

namespace PixelPalsBlazor.Data;

// Provides Entity Framework Core with access to the
// database used by the Pixel Pals prototype.
public class AppDbContext : DbContext
{
    public AppDbContext(DbContextOptions<AppDbContext> options)
        : base(options)
    {
    }

    // Represents the Users table in the SQLite database.
    public DbSet<User> Users { get; set; }
}