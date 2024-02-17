import matplotlib.pyplot as plt
import numpy as np

# Create a range of values from 0 to 5 with a step of 0.2
t = np.arange(0., 5., 0.2)

# Red dashes, blue squares and green triangles
plt.plot(t, t, 'r--', t, t**2, 'bs', t, t**3, 'g^')
plt.show()
