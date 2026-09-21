import express from "express";

import eventsRouter from "./routes/events.js";
import accountsRouter from "./routes/accounts.js";
import registrationsRouter from "./routes/registrations.js";
import donationsRouter from "./routes/donations.js";

const app = express();

const PORT = 3000;

app.use(express.json());

app.get("/", (req, res) => {
    res.status(200).json({
        message: "Pixel Pals API is running"
    });
});

app.use("/api/events", eventsRouter);
app.use("/api/accounts", accountsRouter);
app.use("/api/registrations", registrationsRouter);
app.use("/api/donations", donationsRouter);

app.listen(PORT, () => {
    console.log(`Pixel Pals API running on http://localhost:${PORT}`);
});