// Stores the JWT returned by FastAPI after a successful login.
let accessToken = "";


// Requirement 1: Register a new Pixel Pals user.
document.getElementById("register-form").addEventListener("submit", async function(event) {
    event.preventDefault();

    const name = document.getElementById("register-name").value;
    const email = document.getElementById("register-email").value;
    const password = document.getElementById("register-password").value;

    const response = await fetch("/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password
        })
    });

    const data = await response.json();

    if (response.ok) {
        document.getElementById("register-message").textContent =
            "Account registered successfully.";
    } else {
        document.getElementById("register-message").textContent =
            data.detail;
    }
});


// Requirement 1: Login and store the JWT returned by FastAPI.
document.getElementById("login-form").addEventListener("submit", async function(event) {
    event.preventDefault();

    const email = document.getElementById("login-email").value;
    const password = document.getElementById("login-password").value;

    const response = await fetch("/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    });

    const data = await response.json();

    if (response.ok) {
        accessToken = data.access_token;

        document.getElementById("login-message").textContent =
            "Login successful.";
    } else {
        document.getElementById("login-message").textContent =
            data.detail;
    }
});


// Requirements 1 and 3: Retrieve the authenticated user's stored account data.
document.getElementById("account-button").addEventListener("click", async function() {

    if (accessToken === "") {
        alert("Please login first.");
        return;
    }

    const response = await fetch("/account", {
        method: "GET",
        headers: {
            "Authorization": "Bearer " + accessToken
        }
    });

    const data = await response.json();

    if (response.ok) {
        document.getElementById("account-name").textContent = data.name;
        document.getElementById("account-email").textContent = data.email;
        document.getElementById("account-tokens").textContent = data.tokens;
    } else {
        alert(data.detail);
    }
});


// Requirement 2: Complete an authenticated token transaction.
document.getElementById("transaction-form").addEventListener("submit", async function(event) {
    event.preventDefault();

    if (accessToken === "") {
        alert("Please login first.");
        return;
    }

    const amount = parseInt(
        document.getElementById("transaction-amount").value
    );

    const response = await fetch("/transaction", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + accessToken
        },
        body: JSON.stringify({
            amount: amount
        })
    });

    const data = await response.json();

    if (response.ok) {
        document.getElementById("transaction-message").textContent =
            "Transaction successful. Remaining tokens: " +
            data.remaining_tokens;

        // Update the displayed token balance after the database is updated.
        document.getElementById("account-tokens").textContent =
            data.remaining_tokens;
    } else {
        document.getElementById("transaction-message").textContent =
            data.detail;
    }
});