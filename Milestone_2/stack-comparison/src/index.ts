import { criteria, stacks, scores } from "./config";
import { rankStacks } from "./rank";
import { printTable, writeJsonReport } from "./report";
import { explainResults } from "./explain";


async function main() {

    // Calculates the comparison results using the configured
    // criteria, framework stacks and prototype scores.
    const results = rankStacks(
        stacks,
        criteria,
        scores
    );


    // Displays the deterministic comparison results.
    printTable(results);


    // Saves the deterministic results so they can be used as evidence
    // when writing the framework comparison report.
    writeJsonReport(
        results,
        "report.json"
    );

    console.log("Comparison complete. Results saved to report.json.");


    // Generates an optional AI explanation when "explain"
    // is included in the command.
    if (process.argv.includes("explain")) {
        console.log("\nGenerating AI explanation...\n");

        const explanation = await explainResults(
            results,
            criteria,
            scores
        );

        console.log(explanation);
    }
}


main().catch((error) => {
    console.error("An error occurred:", error);
    process.exit(1);
});