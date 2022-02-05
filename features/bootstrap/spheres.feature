@spheres
Feature: Spheres

    Scenario: A ray intersects a sphere at two points
        Given r <- point(0, 0, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0] = 4.0
        And xs[1] = 6.0

    Scenario: A ray intersects a sphere at a tangent
        Given r <- point(0, 1, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0] = 5.0
        And xs[1] = 5.0

    Scenario: A ray misses a sphere
        Given r <- point(0, 2, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 0

    Scenario: A ray originates a a sphere
        Given r <- point(0, 0, 0) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0] = -1.0
        And xs[1] = 1.0

    Scenario: A sphere behind a ray
        Given r <- point(0, 0, 5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0] = -6.0
        And xs[1] = -4.0

    Scenario: An intersection encapsulates t and object
        Given s <- sphere
        When i <- intersect(3.5, i)
        Then i.t = 3.5
        And i.object = s

    Scenario: Aggregating intersection
        Given s <- sphere
        And i1 <- intersection(1, s)
        And i2 <- intersection(2, s)
        When xs <- intersections(i1, i2)
        Then xs.count = 2
        And xs[0].t = 1
        And xs[1].t = 2

    Scenario: Intersect sets the object on the intersection
        Given r <- point(0, 0, 5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0].object = s
        And xs[1].object = s

    Scenario: A sphere default transformation
        Given s <- sphere
        Then s.transform = identify_matrix

    Scenario: Changing a sphere's transformation
        Given s <- sphere
        And t <- translation(2, 3, 4)
        When set_transform(s, t)
        Then s.transform = t

    Scenario: Intersecting a scaled sphere with a ray
        Given r <- point(0, 0, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When set_transform(s, scaling(2, 2, 2))
        And xs <- intersect(s, r)
        Then xs.count = 2
        And xs[0].t = 3
        And xs[1].t = 7

    Scenario: Intersecting a translated sphere with a ray
        Given r <- point(0, 0, -5) vector(0, 0, 1) spheres.feature
        And s <- sphere
        When set_transform(s, translation(2, 2, 2))
        And xs <- intersect(s, r)
        Then xs.count = 0
    
    Scenario: The normal on a sphere at a point on the x axis
        Given s <- sphere
        When n <- normal_at(s, point(1, 0, 0))
        Then n = vector(1, 0, 0)

    Scenario: The normal on a sphere at a point on the y axis
        Given s <- sphere
        When n <- normal_at(s, point(0, 1, 0))
        Then n = vector(0, 1, 0)

    Scenario: The normal on a sphere at a point on the z axis
        Given s <- sphere
        When n <- normal_at(s, point(0, 0, 1))
        Then n = vector(0, 0, 1)

    Scenario: The normal on a sphere at a nonaxial point
        Given s <- sphere
        When n <- normal_at(s, point(0.57735026919, 0.57735026919, 0.57735026919))
        Then n = vector(0.57735026919, 0.57735026919, 0.57735026919)

    Scenario: The normal is normalized vector
        Given s <- sphere
        When n <- normal_at(s, point(0.57735026919, 0.57735026919, 0.57735026919))
        Then n = normalize(n)

    Scenario: Computing the normal on the translated sphere
        Given s <- sphere
        And set_transform(s, translation(0, 1, 0))
        When n <- normal_at(s, point(0, 1.70711, -0.70711))
        Then n = vector(0, 0.70711, -0.70711)

    Scenario: Computing the normal on the transformed sphere
        Given s <- sphere
        And m <- scaling(1, 0.5, 1) * rotation_z(0.62831853071)
        And set_transform(s, m)
        When n <- normal_at(s, point(0, 0.70710678118, -0.70710678118))
        Then n = vector(0, 0.97014, -0.24254)