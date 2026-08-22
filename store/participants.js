import fs from "fs/promises";

const DATA_FILE = "./data/participants.json";


async function load() {
    const data = await fs.readFile(DATA_FILE, "utf-8");
    return JSON.parse(data);
}


async function save(participants) {
    await fs.writeFile(DATA_FILE, JSON.stringify(participants, null, 4));
}


export async function getAll() {
    return await load();
}


export async function getByRegistrationId(registrationId) {
    const participants = await load();

    return participants.filter(participant => participant.registrationId === registrationId);
}


export async function create(participantData) {
    const participants = await load();

    const newParticipant = {
        participantId: participants.length > 0 ? Math.max(...participants.map(participant => participant.participantId)) + 1 : 1,
        registrationId: participantData.registrationId,
        participantName: participantData.participantName
    };

    participants.push(newParticipant);
    await save(participants);

    return newParticipant;
}