import { Router } from "express";
import * as store from "../store/events.js";

const router = Router();


// GET all events
router.get("/", async (req, res) => {
    try {
        const events = await store.getAll();

        res.status(200).json(events);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to load events" });
    }
});


// GET one event
router.get("/:id", async (req, res) => {
    try {
        const id = Number(req.params.id);
        const event = await store.getById(id);

        if (!event) {
            return res.status(404).json({ message: "Event not found" });
        }

        res.status(200).json(event);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to load event" });
    }
});


// POST create event
router.post("/", async (req, res) => {
    try {
        const { eventName, eventDate, eventTime, location, game, maxTeams } = req.body;

        if (!eventName || !eventDate || !eventTime || !location || !game || maxTeams === undefined) {
            return res.status(400).json({ message: "All event fields are required" });
        }

        const newEvent = await store.create(req.body);

        res.status(201).json(newEvent);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to create event" });
    }
});


// PUT update event
router.put("/:id", async (req, res) => {
    try {
        const id = Number(req.params.id);
        const { eventName, eventDate, eventTime, location, game, maxTeams } = req.body;

        if (!eventName || !eventDate || !eventTime || !location || !game || maxTeams === undefined) {
            return res.status(400).json({ message: "All event fields are required" });
        }

        const updatedEvent = await store.update(id, req.body);

        if (!updatedEvent) {
            return res.status(404).json({ message: "Event not found" });
        }

        res.status(200).json(updatedEvent);
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to update event" });
    }
});


// DELETE event
router.delete("/:id", async (req, res) => {
    try {
        const id = Number(req.params.id);
        const deletedEvent = await store.remove(id);

        if (!deletedEvent) {
            return res.status(404).json({ message: "Event not found" });
        }

        res.status(200).json({
            message: "Event deleted successfully",
            event: deletedEvent
        });
    } catch (err) {
        console.error(err);
        res.status(500).json({ message: "Failed to delete event" });
    }
});


export default router;