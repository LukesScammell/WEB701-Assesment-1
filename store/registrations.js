import fs from "fs/promises";

const DATA_FILE = "./data/registrations.json";


async function load() {
    const data = await fs.readFile(DATA_FILE, "utf-8");
    return JSON.parse(data);
}


async function save(registrations) {
    await fs.writeFile(DATA_FILE, JSON.stringify(registrations, null, 4));
}


export async function getAll() {
    return await load();
}


export async function getById(id) {
    const registrations = await load();

    return registrations.find(registration => registration.registrationId === id);
}


export async function create(registrationData) {
    const registrations = await load();

    const newRegistration = {
        registrationId: registrations.length > 0 ? Math.max(...registrations.map(registration => registration.registrationId)) + 1 : 1,
        eventId: registrationData.eventId,
        accountId: registrationData.accountId,
        teamName: registrationData.teamName
    };

    registrations.push(newRegistration);
    await save(registrations);

    return newRegistration;
}