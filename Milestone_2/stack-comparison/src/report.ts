import { writeFileSync } from "node:fs";
import { ScoredResult } from "./types";


// Displays the comparison results as a table in the terminal.
export function printTable(results: ScoredResult[]): void {
    console.table(
        results.map(result => ({
            Stack: result.stack.name,
            Total: result.total,
            ...Object.fromEntries(
                Object.entries(result.breakdown).map(
                    ([criterion, score]) => [
                        criterion,
                        score.toFixed(2)
                    ]
                )
            )
        }))
    );
}


// Saves the comparison results to a JSON file.
export function writeJsonReport(
    results: ScoredResult[],
    path: string
): void {
    writeFileSync(
        path,
        JSON.stringify(results, null, 2),
        "utf-8"
    );
}