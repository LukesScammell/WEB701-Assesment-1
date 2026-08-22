import { Router } from "express";
import * as registrationStore from "../store/registrations.js";
import * as participantStore from "../store/participants.js";

const router = Router();


// GET one registration
router.get("/:id", async (req, res) => {
    try {
        const id = Number(req.params.id);

        const registration = await registrationStore.getById(id);

        if (!registration) {
            return res.status(404).json({ message: "Registration not found" });
        }

        const participants = await participantStore.getByRegistrationId(id);

        res.status(200).json({
            ...registration,
            participants
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to load registration" });
    }
});


// POST create registration
router.post("/", async (req, res) => {
    try {
        const { eventId, accountId, teamName } = req.body;

        if (!eventId || !accountId || !teamName) {
            return res.status(400).json({ message: "Event, account and team name are required" });
        }

        const newRegistration = await registrationStore.create(req.body);

        res.status(201).json(newRegistration);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to create registration" });
    }
});


// POST add participant
router.post("/:id/participants", async (req, res) => {
    try {
        const registrationId = Number(req.params.id);
        const { participantName } = req.body;

        const registration = await registrationStore.getById(registrationId);

        if (!registration) {
            return res.status(404).json({ message: "Registration not found" });
        }

        if (!participantName) {
            return res.status(400).json({ message: "Participant name is required" });
        }

        const newParticipant = await participantStore.create({
            registrationId,
            participantName
        });

        res.status(201).json(newParticipant);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to add participant" });
    }
});


export default router;