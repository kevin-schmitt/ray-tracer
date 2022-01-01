Feature: Tuples
    Scenario: point() creates tuples with w=1
        Given p <- point("4.3, -4.2, 3.1, 1.0")
        Then p = tuple("4.3, -4.2, 3.1, 1.0")
    Scenario: vector() creates tuples with w=0
        Given p <- vector("4.3, -4.2, 3.1, 0.0")
        Then p = tuple("4.3, -4.2, 3.1, 0.0")
