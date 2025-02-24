const Queue = require("bull");
const { Client } = require("pg");

// Setup Redis Queue
const dataQueue = new Queue("sensorData", { redis: { port: 6379, host: "127.0.0.1" } });

// PostgreSQL Client Setup
const dbClient = new Client({
    host: "localhost",
    port: 5432,
    user: "postgres",
    password: "W@rung01", // Ganti jika perlu
    database: "ccmsv1_alfasolusi"
});

// Connect to PostgreSQL
dbClient.connect()
    .then(() => console.log("✅ Connected to PostgreSQL"))
    .catch(err => console.error("❌ PostgreSQL Connection Error:", err.stack));

// Worker untuk memproses data dari Redis Queue
dataQueue.process(async (job) => {
    const { name, value, node_id, status, count_over_temp, datetime } = job.data;

    try {
        // Ambil count terakhir dari database
        const res = await dbClient.query("SELECT count_over_temp FROM sensor_data ORDER BY id DESC LIMIT 1");
        let count = res.rows[0] ? res.rows[0].count_over_temp : 0;

        // Increment count jika suhu > 29
        if (status === 1) count++;

        // Buat query insert
        const query = `
            INSERT INTO sensor_data (name, value, node_id, status_alarm, count_over_temp, created_at)
            VALUES ($1, $2, $3, $4, $5, $6)
        `;
        const values = [name, value, node_id, status, count, datetime];

        // Eksekusi query insert
        await dbClient.query(query, values);
        console.log(`✅ Data inserted at ${datetime}`);

    } catch (err) {
        console.error("❌ DB Insert Error:", err.message);
        console.error("Full Error:", err.stack);
    }
});

// Graceful Shutdown untuk koneksi DB
process.on("SIGINT", async () => {
    await dbClient.end();
    console.log("🚪 PostgreSQL Disconnected");
    process.exit();
});
