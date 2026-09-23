import {
    Criterion,
    StackCandidate,
    ScoreMatrix,
    ScoredResult
} from "./types";

import { scoreStack } from "./engine";


// Checks that all criterion weights add up to 1.00.
export function validateWeights(criteria: Criterion[]): void {
    const totalWeight = criteria.reduce(
        (total, criterion) => total + criterion.weight,
        0
    );

    if (Math.abs(totalWeight - 1) > 0.0001) {
        throw new Error(
            `Criterion weights must total 1.00. Current total: ${totalWeight}`
        );
    }
}


// Calculates the results for all stacks that currently have scores.
export function rankStacks(
    stacks: StackCandidate[],
    criteria: Criterion[],
    scores: ScoreMatrix
): ScoredResult[] {

    validateWeights(criteria);

    // Only includes stacks that have been evaluated so far.
    const evaluatedStacks = stacks.filter(
        stack => scores[stack.id] !== undefined
    );

    const results = evaluatedStacks.map(
        stack => scoreStack(stack, criteria, scores)
    );

    // Highest weighted score appears first.
    return results.sort((a, b) => b.total - a.total);
}