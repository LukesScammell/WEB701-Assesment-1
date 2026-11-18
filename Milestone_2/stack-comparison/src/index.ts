import { criteria, stacks, scores } from "./config";
import { rankStacks } from "./rank";
import { printTable, writeJsonReport } from "./report";


// Calculates the comparison results using the configured
// criteria, framework stacks and prototype scores.
const results = rankStacks(
    stacks,
    criteria,
    scores
);


// Displays the results in the terminal.
printTable(results);


// Saves the results so they can be used as evidence
// when writing the framework comparison report.
writeJsonReport(
    results,
    "report.json"
);

console.log("Comparison complete. Results saved to report.json.");