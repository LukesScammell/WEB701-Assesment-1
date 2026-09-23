// Represents one criterion used to compare the web stacks.
export interface Criterion {
    id: string;
    label: string;
    weight: number;
}

// Represents one complete web technology stack.
export interface StackCandidate {
    id: string;
    name: string;
}

// Stores the 1-10 scores for each stack and criterion.
export type ScoreMatrix = Record<string, Record<string, number>>;

// Stores the calculated result for a stack.
export interface ScoredResult {
    stack: StackCandidate;
    total: number;
    breakdown: Record<string, number>;
}