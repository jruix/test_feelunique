Feature: Testing 3x2 offers disabled

Scenario: "3 for the price of 2" is disabled
Given the "3x2" offer is disabled
When the following products are put on the order:
    | Category | Title                                      | Price |
    | Lipstick | Rimmel Lasting Finish Lipstick 4g          | 4.99  |
    | Lipstick | bareMinerals Marvelous Moxie Lipstick 3.5g | 13.95 |
    | Lipstick | Rimmel Kate Lasting Finish Matte Lipstick  | 5.49  |
Then I should not get anything for free
And the order total should be "24.43"
