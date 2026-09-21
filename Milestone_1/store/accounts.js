import fs from "fs/promises";

const DATA_FILE = "./data/accounts.json";


async function load() {
    const data = await fs.readFile(DATA_FILE, "utf-8");
    return JSON.parse(data);
}


async function save(accounts) {
    await fs.writeFile(DATA_FILE, JSON.stringify(accounts, null, 4));
}


export async function getAll() {
    return await load();
}


export async function getById(id) {
    const accounts = await load();

    return accounts.find(account => account.accountId === id);
}


export async function getByEmail(email) {
    const accounts = await load();

    return accounts.find(account => account.email === email);
}


export async function create(accountData) {
    const accounts = await load();

    const newAccount = {
        accountId: accounts.length > 0 ? Math.max(...accounts.map(account => account.accountId)) + 1 : 1,
        firstName: accountData.firstName,
        lastName: accountData.lastName,
        email: accountData.email,
        password: accountData.password,
        role: "user"
    };

    accounts.push(newAccount);
    await save(accounts);

    return newAccount;
}


export async function login(email, password) {
    const accounts = await load();

    return accounts.find(account => account.email === email && account.password === password);
}