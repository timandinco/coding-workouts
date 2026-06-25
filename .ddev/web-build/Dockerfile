ARG BASE_IMAGE
FROM $BASE_IMAGE
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests python3 python-is-python3 python3-pip
# RUN pip3 install somepackage # Add any specific pip packages you need