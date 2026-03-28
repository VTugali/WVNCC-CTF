echo "Waiting for Ollama to start..."
sleep 5
until curl -s http://localhost:11434 > /dev/null; do
    echo "Still waiting..."
    sleep 3
done
echo "Ollama is up! Pulling tinyllama model..."
docker exec ollama ollama pull tinyllama
echo "Model ready!"

