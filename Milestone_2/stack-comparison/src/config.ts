import { Criterion, StackCandidate, ScoreMatrix } from "./types";

// Criteria used to compare each framework for the Pixel Pals website.
// The weights total 1.00.
export const criteria: Criterion[] = [
    {
        id: "performance",
        label: "Performance & Scalability",
        weight: 0.20
    },
    {
        id: "developer",
        label: "Developer Experience",
        weight: 0.20
    },
    {
        id: "ecosystem",
        label: "Ecosystem Maturity",
        weight: 0.15
    },
    {
        id: "cost",
        label: "Cost",
        weight: 0.15
    },
    {
        id: "security",
        label: "Security Posture",
        weight: 0.15
    },
    {
        id: "talent",
        label: "Talent Availability",
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
        performance: 8,
        developer: 5,
        ecosystem: 8,
        cost: 9,
        security: 9,
        talent: 8
    },

    gradio: {
        performance: 6,
        developer: 8,
        ecosystem: 6,
        cost: 9,
        security: 8,
        talent: 6
    },

    blazor: {
        performance: 8,
        developer: 6,
        ecosystem: 9,
        cost: 8,
        security: 9,
        talent: 8
    },

    laravel: {
        performance: 8,
        developer: 9,
        ecosystem: 9,
        cost: 9,
        security: 9,
        talent: 9
    },

    wordpress: {
        performance: 7,
        developer: 4,
        ecosystem: 10,
        cost: 9,
        security: 8,
        talent: 10
    }
};