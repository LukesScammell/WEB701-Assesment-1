import { Router } from "express";
import * as store from "../store/donations.js";

const router = Router();


// GET all donations
router.get("/", async (req, res) => {
    try {
        const donations = await store.getAll();

        res.status(200).json(donations);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to load donations" });
    }
});


// GET donation total
router.get("/total", async (req, res) => {
    try {
        const total = await store.getTotal();

        res.status(200).json({ totalDonated: total });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to calculate donation total" });
    }
});


// POST create donation
router.post("/", async (req, res) => {
    try {
        const { accountId, amount, cause } = req.body;

        if (!accountId || amount === undefined || !cause) {
            return res.status(400).json({ message: "Account, amount and cause are required" });
        }

        if (Number(amount) <= 0) {
            return res.status(400).json({ message: "Donation amount must be greater than zero" });
        }

        const newDonation = await store.create(req.body);

        res.status(201).json(newDonation);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to create donation" });
    }
});


export default router;