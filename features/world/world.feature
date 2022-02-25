@world
Feature: World
    Scenario: Creating a world
        Given w <- world()
        Then w contains no objects
        And w has no light source

    Scenario: the default world
        Given light <- point_light(point(-10, 10, -10), color(1, 1, 1))
        And s1 <- sphere() with:
        | material.color | material.diffuse | material.specular |
        | (0.8, 1.0, 0.6)| 0.7              |  0.2              |
        And s2 <- sphere with:
        | transform              | 
        | scaling(0.5, 0.5, 0.5) | 
        When w <- default_world()
        Then w.light = light
        And w contains s1
        And w contains s2

    Scenario: Intersect a world with a ray
        Given w <- default_world()
        And r <- point(0, 0, -5) vector(0, 0, 1)
        When xs <- intersect_world(w, r)
        Then xs.count = 4
        And xs[0].t = 4
        And xs[1].t = 4.5
        And xs[2].t = 5.5
        And xs[3].t = 6