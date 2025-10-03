#!/bin/bash
# Rifassys - Start Servers Script for Linux/Mac
# This script starts all Docker containers for the Rifassys platform

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  RIFASSYS - Starting Docker Services${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}[ERROR] Docker is not running!${NC}"
    echo "Please start Docker and try again."
    exit 1
fi

echo -e "${GREEN}[OK] Docker is running${NC}"
echo ""

# Check if .env file exists
if [ ! -f .env ]; then
    echo -e "${YELLOW}[WARNING] .env file not found!${NC}"
    echo "Creating .env from .env.example..."
    cp .env.example .env
    echo -e "${GREEN}[OK] .env file created${NC}"
    echo "Please edit the .env file with your configurations"
    echo ""
fi

# Stop any running containers
echo -e "${BLUE}[INFO] Stopping existing containers...${NC}"
docker-compose down > /dev/null 2>&1
echo -e "${GREEN}[OK] Previous containers stopped${NC}"
echo ""

# Build and start containers
echo -e "${BLUE}[INFO] Building and starting containers...${NC}"
docker-compose up -d --build

if [ $? -ne 0 ]; then
    echo ""
    echo -e "${RED}[ERROR] Failed to start containers!${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}[OK] All containers started successfully!${NC}"
echo ""

# Wait for database to be ready
echo -e "${BLUE}[INFO] Waiting for database to be ready...${NC}"
sleep 5
echo -e "${GREEN}[OK] Database should be ready${NC}"
echo ""

# Check if vendor directory exists
if [ ! -d "vendor" ]; then
    echo -e "${BLUE}[INFO] Installing Composer dependencies...${NC}"
    docker-compose exec -T app composer install
    echo -e "${GREEN}[OK] Composer dependencies installed${NC}"
    echo ""
fi

# Check if node_modules exists
if [ ! -d "node_modules" ]; then
    echo -e "${BLUE}[INFO] Installing NPM dependencies...${NC}"
    docker-compose exec -T app npm install
    echo -e "${GREEN}[OK] NPM dependencies installed${NC}"
    echo ""
fi

# Check if APP_KEY is set
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${BLUE}[INFO] Generating application key...${NC}"
    docker-compose exec -T app php artisan key:generate
    echo -e "${GREEN}[OK] Application key generated${NC}"
    echo ""
fi

# Run migrations if needed
echo -e "${BLUE}[INFO] Running database migrations...${NC}"
docker-compose exec -T app php artisan migrate --force
echo -e "${GREEN}[OK] Migrations completed${NC}"
echo ""

# Display running containers
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  RUNNING SERVICES${NC}"
echo -e "${BLUE}========================================${NC}"
docker-compose ps
echo ""

# Display access information
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  ACCESS INFORMATION${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo -e "  ${GREEN}Frontend:${NC}  http://localhost:8080"
echo -e "  ${GREEN}Dashboard:${NC} http://localhost:8080/dashboard"
echo -e "  ${GREEN}Admin:${NC}     http://localhost:8080/admin"
echo -e "  ${GREEN}Wuzapi:${NC}    http://localhost:8081"
echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  USEFUL COMMANDS${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo "  View logs:          docker-compose logs -f app"
echo "  Stop servers:       docker-compose down"
echo "  Restart servers:    docker-compose restart"
echo "  Access shell:       docker-compose exec app bash"
echo "  Run artisan:        docker-compose exec app php artisan [command]"
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}  STATUS: READY!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""


