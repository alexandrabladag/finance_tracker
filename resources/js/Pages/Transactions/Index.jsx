export default function Index({ month, transactions }) {
    return (
        <div style={{ padding: '2rem' }}>
            <h1>Transactions</h1>
            <p>Month: {month}</p>

            {transactions.length === 0 ? (
                <p>No transactions found.</p>
            ) : (
                <table border="1" cellPadding="6">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Account</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        {transactions.map(t => (
                            <tr key={t.id}>
                                <td>{t.date}</td>
                                <td>{t.account}</td>
                                <td>{t.category}</td>
                                <td>₱{t.amount}</td>
                                <td>{t.notes}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
        </div>
    );
}
