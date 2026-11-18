import OpenAI from "openai";
import { ScoredResult, Criterion, ScoreMatrix } from "./types";

const client = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

export async function explainResults(
    results: ScoredResult[],
    criteria: Criterion[],
    scores: ScoreMatrix
): Promise<string> {

    const prompt = [
        "You are assisting a senior architect reviewing a web technology stack comparison for the Pixel Pals website.",
        "",
        "Five technology stacks have been evaluated using six criteria.",
        "",
        "The evaluation criteria mean:",
        "1. Performance & Scalability — throughput, latency, and headroom under realistic load projections.",
        "2. Developer Experience — tooling, debugging, documentation quality, and onboarding speed.",
        "3. Ecosystem Maturity — library availability, community size, and long-term maintenance signals.",
        "4. Cost — licensing, hosting, and infrastructure cost at expected scale.",
        "5. Security Posture — built-in protections, patch cadence, and known CVE history.",
        "6. Talent Availability — local and remote hiring pool, and ramp-up time for new joiners.",
        "",
        "Each stack has been given a raw score from 1 to 10 for each criterion.",
        "Each criterion also has a weight that determines its contribution to the final weighted score.",
        "The breakdown values in the calculated results are weighted contributions, not the original raw scores.",
        "",
        "For EACH stack provide:",
        "1. Raw scores out of 10.",
        "2. Weighted contributions.",
        "3. Final weighted total out of 10.",
        "4. Two strengths implied by the scores.",
        "5. Two risks NOT captured by the six evaluation criteria.",
        "6. One open question that should be investigated before selecting the stack.",
        "",
        "Base strengths on the supplied scores and criteria.",
        "Do not invent evidence that is not supplied.",
        "Clearly flag claims that require further verification.",
        "Do not change any scores.",
        "Do not calculate a different ranking.",
        "Do not select or recommend a winning stack.",
        "",
        "CRITERIA AND WEIGHTS:",
        JSON.stringify(criteria, null, 2),
        "",
        "RAW SCORES:",
        JSON.stringify(scores, null, 2),
        "",
        "CALCULATED WEIGHTED RESULTS:",
        JSON.stringify(results, null, 2),
    ].join("\n");

    const response = await client.responses.create({
        model: "gpt-5.6",
        input: prompt,
    });

    return response.output_text;
}