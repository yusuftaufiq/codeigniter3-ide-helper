# From official alpine image.
FROM php:5.6-stretch

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install dependencies.
RUN apt-get update \
    && apt-get install -y sudo \
    && apt-get install -y git

# Create the user.
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME \
    && echo $USERNAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

# Create the vs-code extension directory.
RUN mkdir -p /home/$USERNAME/.vscode-server/extensions \
    /home/$USERNAME/.vscode-server-insiders/extensions \
    && chown -R $USERNAME \
    /home/$USERNAME/.vscode-server \
    /home/$USERNAME/.vscode-server-insiders

# Set the default user.
USER $USERNAME

# Prevent container from exiting early.
CMD ["sleep", "infinity"]
