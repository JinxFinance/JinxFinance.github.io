import os
import time
import site
import pathlib


def get_installation_date(package_name):
    package_path = pathlib.Path(site.getsitepackages()[0]) / package_name
    if not package_path.exists():
        return None
    timestamp = os.path.getctime(package_path)
    return time.ctime(timestamp)


# replace 'mod' with your package name
print(get_installation_date('tensorflow'))
