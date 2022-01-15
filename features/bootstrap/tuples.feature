Feature: Tuples

    Scenario: point() creates tuples with w=1
        Given p <- point("4.3, -4.2, 3.1, 1.0")
        Then p = tuple("4.3, -4.2, 3.1, 1.0")

    Scenario: vector() creates tuples with w=0
        Given p <- vector("4.3, -4.2, 3.1, 0.0")
        Then p = tuple("4.3, -4.2, 3.1, 0.0")

    Scenario: Adding two tuples
        Given a1 <- tuple("3, -2, 5, 1.0")
        And a2 <- tuple("-2, 3, 1, 0.0")
        Then a1 + a2  = tuple("1, 1, 6, 1.0")

    Scenario: Substrating two points
        Given p1 <- point("3, 2, 1")
        And p2 <- point("5, 6, 7")
        Then p1 - p2 = vector("-2, -4, -6")

    Scenario: Substrating a vector from a point
        Given v1 <- vector("3, 2, 1")
        And p2 <- point("5, 6, 7")
        Then v1 - p2 = point("-2, -4, -6")

    Scenario: Substrating two vectors
        Given v1 <- vector("3, 2, 1")
        And v2 <- vector("5, 6, 7")
        Then v1 - v2 = point("-2, -4, -6")

    Scenario: Substrating a vector from the zero vector
        Given zero <- vector("0, O, 0")
        And v2 <- vector("1, -2, 3")
        Then zero - v2 = vector("-1, 2, -3")

    Scenario: Negating a tuple
        Given a <- vector("1, -2, 3, -4")
        Then -a = vector("-1, 2, -3, 4")

    Scenario: Multiplying a tuple by scalar
        Given a <- tuple("1, -2, 3, -4")
        Then a * 3.5 = tuple("3.5, -7, 10.5, -14")

    Scenario: Multiplying a tuple by fraction
        Given a <- tuple("1, -2, 3, -4")
        Then a * 0.5 = tuple("0.5, -1, 1.5, -2")

    Scenario: Divding a tuple by scalar
        Given a <- tuple("1, -2, 3, -4")
        Then a / 2 = tuple("0.5, -1, 1.5, -2")

    Scenario: Computing the magnitude of vector(1, 0, 0)
        Given v <- vector("1, 0, 0")
        Then magnitude = 1

    Scenario: Computing the magnitude of vector(0, 1, 0)
        Given v <- vector("0, 1, 0")
        Then magnitude = 1

    Scenario: Computing the magnitude of vector(0, 0, 1)
        Given v <- vector("0, 0, 1")
        Then magnitude = 1

    Scenario: Computing the magnitude of vector(1, 2, 3)
        Given v <- vector("1, 2, 3")
        Then magnitude = 3.7416573867739

    Scenario: Computing the magnitude of vector(-1, -2, -3)
        Given v <- vector("-1, -2, -3")
        Then magnitude = 3.7416573867739

    Scenario: Normalizing vector(4, 0, 0) gives (1, 0, 0)
        Given v <- vector("4, 0, 0")
        Then normalize = vector("1, 0, 0")

    Scenario: Normalizing vector(1, 2, 3) gives (1, 0, 0)
        Given v <- vector("1, 2, 3")
        Then normalize = apprixomately vector("0.26726, 0.53452, 0.80178")

    Scenario: Normalazing vector(4, 0, 0) gives (1, 0, 0)
        Given v <- vector("4, 0, 0")
        Then normalize = vector("1, 0, 0")

    Scenario: The magnitude of normalize vector
        Given v <- vector("1, 2, 3")
        When norm <- normalize
        Then magnitude = 1

    Scenario: The dot product of two vectors
        Given a <- vector("1, 2, 3")
        And b <- vector("2, 3, 4")
        Then dot = 20

    Scenario: The cros product of two vectors
        Given a <- vector("1, 2, 3")
        And b <- vector("2, 3, 4")
        Then cross for a, b = vector("-1, -1, 2")
        And cross for b, a = vector("1, 1, -2")
