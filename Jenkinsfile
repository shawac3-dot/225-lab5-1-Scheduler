pipeline {
    agent any

    environment {
        IMAGE_NAME = "lab5.1-php-app"
        DOCKER_REGISTRY = "your-docker-registry.com"
        DEV_NAMESPACE = "dev"
        PROD_NAMESPACE = "prod"
        KUBE_CONTEXT = "your-k8s-context"
        MYSQL_PASSWORD = "rootpassword"
    }

    stages {
        stage('Checkout SCM') {
            steps { checkout scm }
        }
        stage('Code Checkout') { steps { sh 'ls -la' } }
        stage('Lint HTML/PHP') {
            steps {
                sh "find . -name '*.php' -exec php -l {} \;"
            }
        }
        stage('Build & Push Docker Image') {
            steps {
                sh "docker build -t $DOCKER_REGISTRY/$IMAGE_NAME:latest ."
                sh "docker push $DOCKER_REGISTRY/$IMAGE_NAME:latest"
            }
        }
        stage('Deploy to Dev Environment') {
            steps {
                sh "kubectl --context $KUBE_CONTEXT set image deployment/lab5.1-dev lab5.1=$DOCKER_REGISTRY/$IMAGE_NAME:latest -n $DEV_NAMESPACE"
                sh "kubectl --context $KUBE_CONTEXT rollout status deployment/lab5.1-dev -n $DEV_NAMESPACE"
            }
        }
        stage('Run Security Checks') { steps { sh "phpstan analyse src --level max || true" } }
        stage('Reset DB') { steps { sh "mysql -u root -p$MYSQL_PASSWORD scheduling_db < database.sql" } }
        stage('Generate Test Data') { steps { sh "php generate_test_data.php" } }
        stage('Run Acceptance Tests') { steps { sh "phpunit tests/" } }
        stage('Remove Test Data') { steps { sh "php remove_test_data.php" } }
        stage('Deploy to Prod Environment') {
            steps {
                sh "kubectl --context $KUBE_CONTEXT set image deployment/lab5.1-prod lab5.1=$DOCKER_REGISTRY/$IMAGE_NAME:latest -n $PROD_NAMESPACE"
                sh "kubectl --context $KUBE_CONTEXT rollout status deployment/lab5.1-prod -n $PROD_NAMESPACE"
            }
        }
        stage('Check Kubernetes Cluster') { steps { sh "kubectl --context $KUBE_CONTEXT get pods -n $PROD_NAMESPACE" } }
    }

    post {
        always { cleanWs(); archiveArtifacts artifacts: '**/*.log', allowEmptyArchive: true }
        success { echo "Pipeline completed successfully ✅" }
        failure { echo "Pipeline failed ❌" }
    }
}