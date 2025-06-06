const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
require("dotenv").config();
const stripe = require("stripe")(process.env.STRIPE_SECRET_KEY);

const app = express();
const port = 5000;

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(cors());

app.post("/payment_intent", async (req, res) => {
    try {
        const { amount, payment_method } = req.body;
        if (!amount || amount <= 0) {
            return res.status(400).json({ error: { message: "Invalid amount" } });
        }
        const paymentIntent = await stripe.paymentIntents.create({
            amount: Math.round(amount * 100),
            currency: "usd",
            payment_method,
            confirmation_method: "automatic",
        });

        res.json({ clientSecret: paymentIntent.client_secret });
        } catch (error) {
        console.error("Stripe Error:", error.message);
        res.status(400).json({ error: { message: error.message } });
    }
});
app.post("/confirm_payment", async (req, res) => {
    try {
        const { paymentIntentId, payment_method } = req.body;

        if (!paymentIntentId) {
            return res.status(400).json({ error: { message: "Missing PaymentIntent ID" } });
        }
        const paymentIntent = await stripe.paymentIntents.confirm(paymentIntentId, {
            payment_method, 
        });

        res.json({ success: true, paymentIntent });
    } catch (error) {
        console.error("Stripe Error:", error.message);
        res.status(400).json({ error: { message: error.message } });
    }
});

app.get("/course/:id/payment-success", (req, res) => {
    const { payment_intent } = req.query;
    const { id } = req.params;
    // You can customize the response as needed
    res.json({
        message: "Payment successful",
        courseId: id,
        paymentIntent: payment_intent
    });
});

app.listen(port, () => {
    console.log(`Server running on http://localhost:${port}`);
});
