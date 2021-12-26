Feature: Arrays operations
    Scenario: Concatenating two arrays should create new array
        Given a <- array("1, 2, 3")
        And b <- array("4, 5, 6")
        When c <- a + b
        Then c = array("1, 2, 3, 4, 5, 6")