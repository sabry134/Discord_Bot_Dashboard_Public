#!/bin/bash

if ! minikube status >/dev/null 2>&1; then
  echo "Minikube is not running. Starting Minikube..."
  minikube start
fi

kubectl apply -f back/service.yaml > /dev/null
kubectl apply -f back/deployment.yaml > /dev/null

minikube_ip=$(minikube ip)
node_port_back=$(kubectl get service discord-api-service -o jsonpath='{.spec.ports[0].nodePort}')

echo "Back available at: http://${minikube_ip}:${node_port_back}/"

kubectl apply -f front/service.yaml > /dev/null
kubectl apply -f front/deployment.yaml > /dev/null

node_port_front=$(kubectl get service discord-front-service -o jsonpath='{.spec.ports[0].nodePort}')

echo "Front available at: http://${minikube_ip}:${node_port_front}/"
