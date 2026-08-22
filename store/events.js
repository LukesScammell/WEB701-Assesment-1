import fs from "fs/promises";

const DATA_FILE = "./data/events.json";


async function load() {
    const data = await fs.readFile(DATA_FILE, "utf-8");
    return JSON.parse(data);
}


async function save(events) {
    await fs.writeFile(DATA_FILE, JSON.stringify(events, null, 4));
}


export async function getAll() {
    return await load();
}


export async function getById(id) {
    const events = await load();
    return events.find(event => event.eventId === id);
}


export async function create(eventData) {
    const events = await load();

    const newEvent = {
        eventId: events.length > 0 ? Math.max(...events.map(event => event.eventId)) + 1 : 1,
        ...eventData
    };

    events.push(newEvent);
    await save(events);

    return newEvent;
}


export async function update(id, eventData) {
    const events = await load();

    const event = events.find(event => event.eventId === id);

    if (!event) {
        return null;
    }

    event.eventName = eventData.eventName;
    event.eventDate = eventData.eventDate;
    event.eventTime = eventData.eventTime;
    event.location = eventData.location;
    event.game = eventData.game;
    event.maxTeams = eventData.maxTeams;

    await save(events);

    return event;
}


export async function remove(id) {
    const events = await load();

    const index = events.findIndex(event => event.eventId === id);

    if (index === -1) {
        return null;
    }

    const deletedEvent = events.splice(index, 1)[0];

    await save(events);

    return deletedEvent;
}