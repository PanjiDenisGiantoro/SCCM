const opcua = require("node-opcua");
const Queue = require("bull");

// Setup Redis Queue
const dataQueue = new Queue("sensorData", { redis: { port: 6379, host: "127.0.0.1" } });

// OPC UA Client Setup
const client = opcua.OPCUAClient.create({ endpointMustExist: false });
const endpointUrl = "opc.tcp://localhost:4842/UA/MyServer"; // Ganti jika beda
const temperatureNodeId = "ns=1;s=Temperature"; // Ganti sesuai NodeId

let countOverTemp = 0; // Counter over 29

async function readData() {
    try {
        // Koneksi ke OPC UA Server
        await client.connect(endpointUrl);
        console.log("✅ Connected to OPC UA Server");

        // Buat sesi
        const session = await client.createSession();
        console.log("📡 Session Created");

        // Baca data tiap detik
        setInterval(async () => {
            try {
                // Baca nilai Temperature
                const tempData = await session.readVariableValue(temperatureNodeId);
                const temperature = tempData.value.value;
                const datetime = new Date().toISOString(); // Tambah datetime

                // Tentukan status
                const status = temperature > 29 ? 1 : 0;

                // Tambah counter jika lebih dari 29
                if (temperature > 29) countOverTemp++;

                console.log(`🌡️ Temperature: ${temperature.toFixed(2)} °C | Status: ${status} | Over 29 Count: ${countOverTemp}`);


                if (countOverTemp % 5 === 0) {
                    await dataQueue.add({
                        name: "Temperature",
                        value: temperature.toFixed(2),
                        node_id: temperatureNodeId,
                        status: status,
                        count_over_temp: countOverTemp,
                        datetime: datetime
                    });
                    countOverTemp =  0; // Reset counter
                }


                console.log("📥 Data sent to Redis Queue");

            } catch (err) {
                console.error("❌ Error reading data:", err.message);
            }
        }, 1000); // Baca tiap 1 detik

    } catch (err) {
        console.error("❌ Connection Error:", err.message);
    }
}

readData();
