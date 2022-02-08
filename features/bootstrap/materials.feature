@materials
Feature: Material
    Scenario: The default material
    Given m <- material()
    Then m.ambient = 0.1
    And m.diffuse = 0.9
    And m.spectacular = 0.9
    And m.shininess = 200.0
