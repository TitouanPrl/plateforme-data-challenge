class testclasse:
    def __init__(self):
        self.a = 1
        self.b = 2
        self.c = 3
    def __str__(self):
        return "a: %d, b: %d, c: %d" % (self.a, self.b, self.c)