@spheres
Feature: Spheres

    Scenario: A ray intersects a sphere at two points
        Given r <- point(0, 0, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0] = 4.0
        And xs[1] = 6.0
