# Goal & Scope: Cricket DLS Pro

## 1. Primary Objective
The main goal of this application is to help players, officials, organizers, and fans accurately calculate revised targets and required runs in rain-interrupted or reduced-overs cricket matches using the Duckworth-Lewis-Stern (DLS) method.

When a match is affected by weather, light, or other interruptions, the original target can become unfair. This app ensures fair result calculation by dynamically adjusting targets based on:
- Overs lost
- Wickets lost
- Runs scored
- Match format

## 2. Core Purpose
This application is designed to:
- Allow users to calculate revised target, runs remaining, and required run rate quickly.
- Remove dependency on manual tables and error-prone calculations.
- Deliver instant, understandable output for practical match decisions.
- Work on mobile and desktop for non-technical users.

## 3. Main Use Case
### Scenario
A cricket match is interrupted by rain. Overs are reduced and the batting side needs a new target.

User flow:
1. Open app.
2. Enter match details.
3. Get instant revised target and chase metrics.

## 4. Inputs Captured
| Input | Description |
| --- | --- |
| Current Runs | Runs scored so far |
| Wickets Lost | Total wickets fallen |
| Overs Played | Overs completed before interruption |
| Total Match Overs | Original match length |
| Target Score | Original target (if chasing) |
| Overs Remaining | New overs after interruption (optional) |

## 5. Outputs Generated
### Primary Outputs
- Revised Target
- Runs Required
- Required Run Rate
- Balls Remaining

### Advanced Outputs
- Target at end of each remaining over
- Required runs per over
- Win/Lose probability (future scope)

## 6. Rain-Interruption Scenarios Covered
### 6.1 Interruption During First Innings
- Recalculates available resources.
- Adjusts expected first-innings benchmark.
- Sets fair target for second innings.

### 6.2 Interruption During Second Innings
- Recalculates revised target mid-chase.
- Updates runs needed and required run rate.

### 6.3 Multiple Interruptions
- Accepts updated inputs at each stoppage.
- Recomputes targets dynamically each time.

### 6.4 Sudden Over Reduction
- Handles major overs cuts (for example 20 overs to 12 overs).
- Rebalances target to prevent unfair advantage.

### 6.5 Minimum-Overs Matches
- Supports short-match cases (5 to 7 overs where valid).
- Applies minimum-over rules before declaring a result.

### 6.6 Target Already Passed
- Detects when revised target is already achieved.
- Declares batting side winner.

### 6.7 All-Out Before Full Overs
- Accounts for innings closure due to wickets.
- Recalculates using consumed resources.

### 6.8 Tied Match / Super Over (Future)
- Future support for tie-break suggestions.

### 6.9 Abandoned Match
- Checks minimum-over eligibility.
- Returns no-result outcome when applicable.

### 6.10 Different Match Formats
| Format | Overs |
| --- | --- |
| T20 | 20 |
| ODI | 50 |
| Custom | Any |

## 7. Fairness & Accuracy Principle
The app uses simplified resource-percentage logic with the following assumptions:
- Wickets reduce scoring potential.
- Fewer overs reduce scoring opportunity.
- More wickets lost means fewer batting resources.
- Revised targets must reflect remaining resources fairly.

## 8. Over-by-Over Projection
If remaining overs are not explicitly provided, the app can generate projected targets:
- For each remaining over.
- In grouped blocks (for example every 5 overs).
- Across special phases (such as powerplay periods, where relevant).

## 9. Target Users
- Umpires
- Tournament organizers
- Coaches
- Analysts
- Cricket fans
- Mobile-first users

Especially useful for school, college, club, street, and semi-professional tournaments.

## 10. Disclaimer
This app uses a simplified public DLS-style model.

It is intended for:
- Education
- Training
- Amateur and local match operations

It is not an official ICC-certified calculator.

## 11. Long-Term Vision
Future versions may include:
- Licensed official DLS table integration
- Match history and audit trails
- Tournament mode
- AI-assisted match prediction
- Cloud sync
- Umpire dashboard

## Final Summary
Cricket DLS Pro provides a fast, practical, and understandable way to compute revised targets in rain-affected matches. By applying DLS-style resource logic to real-time match inputs, it supports fair decision-making across reduced-overs games, multiple interruptions, early all-outs, and abandonment cases while reducing manual calculation errors.
