import { Router } from "express";
import * as store from "../store/accounts.js";

const router = Router();


// GET one account
router.get("/:id", async (req, res) => {
    try {
        const id = Number(req.params.id);
        const account = await store.getById(id);

        if (!account) {
            return res.status(404).json({ message: "Account not found" });
        }

        res.status(200).json(account);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to load account" });
    }
});


// POST create account
router.post("/", async (req, res) => {
    try {
        const { firstName, lastName, email, password } = req.body;

        if (!firstName || !lastName || !email || !password) {
            return res.status(400).json({ message: "All account fields are required" });
        }

        const existingAccount = await store.getByEmail(email);

        if (existingAccount) {
            return res.status(400).json({ message: "An account with that email already exists" });
        }

        const newAccount = await store.create(req.body);

        res.status(201).json(newAccount);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to create account" });
    }
});


// POST login
router.post("/login", async (req, res) => {
    try {
        const { email, password } = req.body;

        if (!email || !password) {
            return res.status(400).json({ message: "Email and password are required" });
        }

        const account = await store.login(email, password);

        if (!account) {
            return res.status(401).json({ message: "Invalid email or password" });
        }

        res.status(200).json({
            message: "Login successful",
            accountId: account.accountId,
            firstName: account.firstName,
            role: account.role
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to login" });
    }
});


export default router;