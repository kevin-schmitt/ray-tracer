@rays
Feature: Rays
    Scenario: Creating a querying a ray
        Given origin <- point(4.3, -4.2, 3.1)
        And direction <- vector(4, 5, 6)
        When r <- ray(origin, direction)
        Then r.origin = origin
        And r.direction = direction

    Scenario: Computing a point from a distance
        Given r <- point(2, 3, 4) vector(1, 0, 0)
        Then position(r, 0) = point(2, 3, 4)
        And position(r, 1) = point(3, 3, 4)
        And position(r, -1) = point(1, 3, 4)
        And position(r, 2.5) = point(4.5, 3, 4)
