import {
    Criterion,
    StackCandidate,
    ScoreMatrix,
    ScoredResult
} from "./types";


// Calculates the weighted score for one web technology stack.
export function scoreStack(
    stack: StackCandidate,
    criteria: Criterion[],
    scores: ScoreMatrix
): ScoredResult {

    const stackScores = scores[stack.id];

    // Stops the comparison if the selected stack has no scores.
    if (!stackScores) {
        throw new Error(`No scores found for stack "${stack.id}"`);
    }

    const breakdown: Record<string, number> = {};
    let total = 0;

    // Calculates the weighted contribution of each criterion.
    for (const criterion of criteria) {
        const score = stackScores[criterion.id];

        // Every criterion must have a score before a result is calculated.
        if (score === undefined) {
            throw new Error(
                `Missing score for "${criterion.id}" on "${stack.id}"`
            );
        }

        // Scores must use the same 1-10 scale.
        if (score < 1 || score > 10) {
            throw new Error(
                `Score for "${criterion.id}" on "${stack.id}" must be between 1 and 10`
            );
        }

        const contribution = score * criterion.weight;

        breakdown[criterion.id] = contribution;
        total += contribution;
    }

    return {
        stack,
        total: Number(total.toFixed(2)),
        breakdown
    };
}