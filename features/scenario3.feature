Feature: Testing 50% offers enabled

Scenario: "Buy Shampoo & get Conditioner for 50% off" osdasdffer
Given the "50%" offer is enabled
When the following products are put on the order:
  | Category    | Title                                 | Price |
  | Shampoo     | Sebamed Anti-Dandruff Shampoo 200ml   | 4.99  |
  | Conditioner | L'Oréal Paris Hair Conditioner 250ml  | 5.50  |
Then I should get a 50% discount on "L'Oréal Paris Hair Conditioner 250ml"
And the order total should be "7.24"
