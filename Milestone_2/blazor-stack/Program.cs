using PixelPalsBlazor.Components;
using Microsoft.EntityFrameworkCore;
using PixelPalsBlazor.Data;
using Microsoft.AspNetCore.Identity;
using PixelPalsBlazor.Models;
using PixelPalsBlazor.Services;

var builder = WebApplication.CreateBuilder(args);

// Connect Entity Framework Core to the Pixel Pals SQLite database.
builder.Services.AddDbContext<AppDbContext>(options =>
    options.UseSqlite(builder.Configuration.GetConnectionString("DefaultConnection")));

// Provides secure password hashing for registered users.
builder.Services.AddScoped<PasswordHasher<User>>();

// Add services to the container.
builder.Services.AddRazorComponents()
    .AddInteractiveServerComponents();

// Provides JWT creation and validation for authentication.
builder.Services.AddScoped<JwtService>();

var app = builder.Build();

// Create the SQLite database and its tables if they do not already exist.
using (var scope = app.Services.CreateScope())
{
    var database = scope.ServiceProvider.GetRequiredService<AppDbContext>();
    database.Database.EnsureCreated();
}

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error", createScopeForErrors: true);
    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
    app.UseHsts();
}

app.UseHttpsRedirection();

app.UseStaticFiles();
app.UseAntiforgery();

app.MapRazorComponents<App>()
    .AddInteractiveServerRenderMode();

app.Run();
