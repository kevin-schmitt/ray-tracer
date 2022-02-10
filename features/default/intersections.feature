@intersections
Feature: Intersections

    Scenario: The hit when all intersection have positive t
        Given s <- sphere intersections.feature
        And i1 <- intersection(1, s) intersections.feature
        And i2 <- intersection(2, s) intersections.feature
        And xs <- intersections(i1, i2) intersections.feature
        When i <- hit(xs)
        Then i = i1

    Scenario: The hit when all intersection have negative t
        Given s <- sphere intersections.feature
        And i1 <- intersection(-1, s) intersections.feature
        And i2 <- intersection(1, s) intersections.feature
        And xs <- intersections(i2, i1) intersections.feature
        When i <- hit(xs)
        Then i = i2

    Scenario: The hit, when some intersections have negative t
        Given s <- sphere intersections.feature
        And i1 <- intersection(-2, s) intersections.feature
        And i2 <- intersection(-1, s) intersections.feature
        And xs <- intersections(i2, i1) intersections.feature
        When i <- hit(xs)
        Then i is nothing

    Scenario: The hit is always the lowest nonegative intersection
        Given s <- sphere intersections.feature
        And i1 <- intersection(-3, s) intersections.feature
        And i2 <- intersection(2, s) intersections.feature
        And i3 <- intersection(5, s) intersections.feature
        And i4 <- intersection(7, s) intersections.feature
        And xs <- intersections(i1, i2, i3, i4) intersections.feature
        When i <- hit(xs)
        Then i = i2