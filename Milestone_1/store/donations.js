import fs from "fs/promises";

const DATA_FILE = "./data/donations.json";


async function load() {
    const data = await fs.readFile(DATA_FILE, "utf-8");
    return JSON.parse(data);
}


async function save(donations) {
    await fs.writeFile(DATA_FILE, JSON.stringify(donations, null, 4));
}


export async function getAll() {
    return await load();
}


export async function getTotal() {
    const donations = await load();

    return donations.reduce((total, donation) => total + Number(donation.amount), 0);
}


export async function create(donationData) {
    const donations = await load();

    const newDonation = {
        donationId: donations.length > 0 ? Math.max(...donations.map(donation => donation.donationId)) + 1 : 1,
        accountId: donationData.accountId,
        amount: Number(donationData.amount),
        donationDate: new Date().toISOString().split("T")[0],
        cause: donationData.cause
    };

    donations.push(newDonation);
    await save(donations);

    return newDonation;
}