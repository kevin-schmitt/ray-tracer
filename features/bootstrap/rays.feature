Feature: Rays

    Scenario: Creating a querying a ray
        Given origin <- point(4.3, -4.2, 3.1)
        And direction <- vector(4, 5, 6)
        When r <- ray(origin, direction)
        Then r.origin = origin
        And r.direction = direction
