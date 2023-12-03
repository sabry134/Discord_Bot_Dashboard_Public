Dashboard Front end: 8080
Dashboard Back end: 3000
Traefik: 8082
Kubernetes: <minikube_ip>:NodePort (To do so, check kubectl get service discord-api-service/kubectl get service discord-front-service) - N.B: ./deploy.sh will automaically give you the link of where your kubernetes host is
Jenkins: 8083