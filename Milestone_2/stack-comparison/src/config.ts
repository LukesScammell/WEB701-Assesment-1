import { Criterion, StackCandidate, ScoreMatrix } from "./types";

// Criteria used to compare each framework for the Pixel Pals website.
// The weights total 1.00.
export const criteria: Criterion[] = [
    {
        id: "development",
        label: "Development Complexity",
        weight: 0.25
    },
    {
        id: "requirements",
        label: "Pixel Pals Requirements",
        weight: 0.25
    },
    {
        id: "security",
        label: "Authentication and Security",
        weight: 0.20
    },
    {
        id: "database",
        label: "Database Integration",
        weight: 0.15
    },
    {
        id: "frontend",
        label: "Frontend Flexibility",
        weight: 0.15
    }
];

// The five framework systems being evaluated.
// Scores will be added only after each prototype has been tested.
export const stacks: StackCandidate[] = [
    {
        id: "fastapi",
        name: "Python / FastAPI"
    },
    {
        id: "gradio",
        name: "Gradio App Stack"
    },
    {
        id: "blazor",
        name: ".NET 8 / Blazor"
    },
    {
        id: "laravel",
        name: "PHP 8 / Laravel + Livewire"
    },
    {
        id: "wordpress",
        name: "WordPress Full Stack"
    }
];

// Scores are added after each framework prototype has been implemented
// and tested. Each criterion uses a score from 1 to 10.
export const scores: ScoreMatrix = {
    fastapi: {
        development: 7,
        requirements: 9,
        security: 9,
        database: 9,
        frontend: 9
    },

    gradio: {
        development: 9,
        requirements: 7,
        security: 8,
        database: 8,
        frontend: 5
    }
};