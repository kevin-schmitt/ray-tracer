@matrices
Feature: Matrices
    Scenario: Constructing and inspecting a 4x4 matrix
        Given the following matrix 4x4 M:
            | 0    | 1    | 2    | 3    |
            | 1    | 2    | 3    | 4    |
            | 5.5  | 6.5  | 7.5  | 4    |
            | 9    | 10   | 11   | 12   |
            | 13.5 | 14.5 | 15.5 | 16.5 |
        Then M[0,0] = 1
        And M[0,3] = 4
        And M[1,0] = 5.5
        And M[1,2] = 7.5
        And M[2,2] = 11
        And M[3,0] = 13.5
        And M[3,2] = 15.5

    Scenario: Constructing and inspecting a 2x2 matrix
        Given the following matrix 4x4 M:
            | 0  | 1  |
            | -3 | 5  |
            | 1  | -2 |
        Then M[0,0] = -3
        And M[0,1] = 5
        And M[1,0] = 1
        And M[1,1] = -2

    Scenario: Matrice equality with identical matrices
        Given the following matrix A:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 5 | 6  | 7 | 8 |
            | 9 | 8  | 7 | 6 |
            | 5 | 4  | 3 | 2 |
        And the following matrix B:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 5 | 6  | 7 | 8 |
            | 9 | 8  | 7 | 6 |
            | 5 | 4  | 3 | 2 |
        Then A = B

    Scenario: Matrice equality with identical matrices
        Given the following matrix A:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 5 | 6  | 7 | 5 |
            | 9 | 8  | 7 | 6 |
            | 5 | 0.6  | 3 | 2 |
        And the following matrix B:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 5 | 6  | 7 | 8 |
            | 9 | 8  | 7 | 2 |
            | 5 | 7  | 3 | 2 |
        Then A != B

    Scenario: Multipliying two matrices
        Given the following matrix A:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 5 | 6  | 7 | 8 |
            | 9 | 8  | 7 | 6 |
            | 5 | 4  | 3 | 2 |
        And the following matrix B:
            | 0  | 1  | 2 | 3  |
            | -2 | 1  | 2 | 3  |
            | 3  | 2  | 1 | -1 |
            | 4  | 3  | 6 | 5  |
            | 1  | 2  | 7 | 8  |
        Then A * B is the following matrix:
            | 0  | 1   | 2   | 3   |
            | 20 | 22  | 50  | 48  |
            | 44 | 54  | 114 | 108 |
            | 40 | 58  | 110 | 102 |
            | 16 | 26  | 46  | 42  |

    Scenario: Matrix multiply by a tuple
        Given the following matrix A:
            | 0 | 1  | 2 | 3 |
            | 1 | 2  | 3 | 4 |
            | 2 | 4  | 4 | 2 |
            | 8 | 6  | 4 | 1 |
            | 0 | 0  | 0 | 1 |
        And the tuple b <- ("1, 2, 3, 1")
        Then matrix A * b = tuple("18, 24, 33, 1")

    Scenario: Multiplying a matrix by identify matrix
        Given the following matrix A:
            | 0 | 1  | 2  | 3   |
            | 0 | 1  | 2  | 4   |
            | 1 | 2  | 4  | 8   |
            | 2 | 4  | 8  | 16  |
            | 4 | 8  | 16 | 32 |
        Then A * identify = A

    Scenario: Multiplying a matrix by a tuple
        Given the tuple a <- ("1, 2, 3, 4")
        Then identify_matrix * a = a

    Scenario: Transposing a matrix
        Given the following matrix A:
            | 0 | 1 | 2 | 3 |
            | 0 | 9 | 3 | 0 |
            | 9 | 8 | 0 | 8 |
            | 1 | 8 | 5 | 3 |
            | 0 | 0 | 5 | 8 |
        Then transpose is the following matrix:
            | 0 | 1 | 2 | 3 |
            | 0 | 9 | 1 | 0 |
            | 9 | 8 | 8 | 0 |
            | 3 | 0 | 5 | 5 |
            | 0 | 8 | 3 | 8 |

    Scenario: The transposing identify matrix
        Given A <- transpose->identify_matrix
        Then A = identify_matrix

    Scenario: Calculating the determinant of 2*2 matrix
        Given the following matrix A:
            | 0  | 1  |
            | 1  | 5  |
            | -3 | 2  |
        Then determinant(A) = 17

    Scenario: A submatrix of a 3x3 matrix is a 2x2 matrix
        Given the following matrix A:
            | 0  | 1  | 2  |
            | 1  | 5  | 0  |
            | -3 | 2  | 7  |
            | 0  | 6  | -3 |
        Then submatrix(0, 2) is the following 2x2 matrix:
            | 0  | 1  |
            | -3 | 2  |
            | 0  | 6  |

    Scenario: A submatrix of a 4x4 matrix is a 3x3 matrix
        Given the following matrix A:
            | 0  | 1  | 2   | 3 |
            | -6 | 1  | 1   | 6 |
            | -8 | 5  | 8   | 6 |
            | -1 | 0  | 8   | 2 |
            | -7 | 1  | -1  | 1 |
        Then submatrix(2, 1) is the following 3x3 matrix:
            | 0  | 1  | 2 |
            | -6 | 1  | 6 |
            | -8 | 8  | 6 |
            | -7 | -1 | 1 |

    Scenario: Calculating a minor of 3x3 matrix
        Given the following matrix A:
            | 0  | 1  | 2  |
            | 3  | 5  | 0  |
            | 2  | -1 | -7 |
            | 6  | -1 | 5  |
        And B <- submatrix(A, 1, 0)
        Then determinant(B) = 25
        And minor(A, 1, 0) = 25

    Scenario: Calculating a cofactor of 3x3 matrix
        Given the following matrix A:
            | 0  | 1  | 2  |
            | 3  | 5  | 0  |
            | 2  | -1 | -7 |
            | 6  | -1 | 5  |
        Then minor(A, 0, 0) = -12
        And cofactor(A, 0, 0) = -12
        And minor(A, 1, 0) = 25
        And cofactor(A, 1, 0) = -25

    Scenario: Calculating the determinant of 3x3 matrix
        Given the following matrix A:
            | 0  | 1  | 2  |
            | 1  | 2  | 6  |
            | -5 | 8  | -4 |
            | 2  | 6  | 4  |
        Then cofactor(A, 0, 0) = 56
        And cofactor(A, 0, 1) = 12
        And cofactor(A, 0, 2) = -46
        And determinant(A) = -196

    Scenario: Calculating the determinant of 3x3 matrix
        Given the following matrix A:
            | 0  | 1  | 2  | 3  |
            | -2 | -8 | 3  | 5  |
            | -3 | 1  | 7  | 3  |
            | 1  | 2  | -9 | 6  |
            | -6 | 7  | 7  | -9 |
        Then cofactor(A, 0, 0) = 690
        And cofactor(A, 0, 1) = 447
        And cofactor(A, 0, 2) = 210
        And cofactor(A, 0, 3) = 51
        And determinant(A) = -4071

    Scenario: Testing an invertible matrix for invertibility
        Given the following matrix A:
            | 0  | 1  | 2  | 3  |
            | 6  | 4  | 4  | 4  |
            | 5  | 5  | 7  | 6  |
            | 4  | -9 | 3  | -7 |
            | 9  | 1  | 7  | -6 |
        Then determinant(A) = -2120
        And A is invertible

    Scenario: Testing an noninvertible matrix for invertibility
        Given the following matrix A:
            | 0  | 1  | 2  | 3  |
            | -4 | 2  | -2 | -3 |
            | 9  | 6  | 2  | 6  |
            | 0  | -5 | 1  | -5 |
            | 0  | 0  | 0  | 0  |
        Then determinant(A) = 0
        And A is not invertible

    Scenario: Calculating the inverse of matrix
        Given the following matrix A:
            | 0  | 1  | 2  | 3  |
            | -5 | 2  | 6  | -8 |
            | 1  | -5 | 1  | 8  |
            | 7  | 7  | -6 | -7 |
            | 1  | -3 | 7  | 4  |
        And B <- inverse(A)
        Then determinant(A) = 532
        And cofactor(A, 2, 3) = -160
        And B[3,2] = -160/532
        And cofactor(A, 3, 2) = 105
        And B[2,3] = 105/532
        And B is the following matrix:
            | 0         | 1        | 2        | 3        |
            | 0.21805   | 0.45113  | 0.24060  | -0.04511 |
            | -0.80827  | -1.45677 | -0.44361 | 0.52068 |
            | -0.07895  | -0.22368 | -0.05263 | 0.19737  |
            | -0.52256  | -0.81391 | -0.30075 | 0.30639  |

    Scenario: Multiplying a product by its inverse
        Given the following matrix A:
            | 0  | 1  | 2  | 3  |
            | 3  | -9 | 7  | 3  |
            | 3  | -8 | 2  | -9 |
            | -4 | 4  | 4  | 1  |
            | -6 | 5  | -1 | 1  |
        And the following matrix B:
            | 0  | 1  | 2  | 3  |
            | 8  | 2  | 2  | 2  |
            | 3  | -1 | 7  | 0  |
            | 7  | 0  | 5  | 4  |
            | 6  | -2 | 0  | 5  |
        And C <- A * B
        Then C * inverse(B) = A