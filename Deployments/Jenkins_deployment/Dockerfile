# FROM jenkins/jenkins:lts
# USER root
# RUN apt-get update && apt-get install -y lsb-release && rm -rf /var/lib/apt/lists/*
# RUN curl -fsSLo /usr/share/keyrings/docker-archive-keyring.asc \
#   https://download.docker.com/linux/debian/gpg
# RUN echo "deb [arch=$(dpkg --print-architecture) \
#   signed-by=/usr/share/keyrings/docker-archive-keyring.asc] \
#   https://download.docker.com/linux/debian \
#   $(lsb_release -cs) stable" > /etc/apt/sources.list.d/docker.list
# RUN apt-get update && apt-get install -y docker-ce-cli
# RUN jenkins-plugin-cli --plugins cloudbees-folder configuration-as-code credentials github instance-identity job-dsl script-security structs role-strategy ws-cleanup
# COPY jenkins.yml /var/jenkins_home/jenkins.yml
# ENV CASC_JENKINS_CONFIG /var/jenkins_home/jenkins.yml

# FROM jenkins/jenkins:lts
# ENV USER_CHOCOLATEEN_PASSWORD test
# ENV JAVA_OPTS -Djenkins.install.runSetupWizard=false
# COPY plugins.txt /usr/share/jenkins/ref/plugins.txt
# RUN jenkins-plugin-cli -f /usr/share/jenkins/ref/plugins.txt
# COPY jenkins.yml /var/jenkins_home/jenkins.yml
# #COPY job_dsl.groovy .
# ENV CASC_JENKINS_CONFIG /var/jenkins_home/jenkins.yml
# ENV USER_CHOCOLATEEN_PASSWORD test
# ENV USER_VAUGIE_G_PASSWORD test
# ENV USER_I_DONT_KNOW_PASSWORD test
# ENV USER_NASSO_PASSWORD test
# USER root
#RUN apt update && apt install -y make gcc libcriterion-dev

FROM jenkins/jenkins:lts
ENV JAVA_OPTS -Djenkins.install.runSetupWizard=false
ENV CASC_JENKINS_CONFIG /var/jenkins_home/jenkins.yml
ENV USER_CHOCOLATEEN_PASSWORD test
ENV USER_VAUGIE_G_PASSWORD test
ENV USER_I_DONT_KNOW_PASSWORD test
ENV USER_NASSO_PASSWORD test

COPY jenkins.yml /var/jenkins_home/
COPY job_dsl.groovy /var/jenkins_home/
RUN jenkins-plugin-cli --plugins configuration-as-code instance-identity job-dsl script-security structs role-strategy ws-cleanup github