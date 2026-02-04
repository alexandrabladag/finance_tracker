import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ month, accounts, summary, budgets }) {
    return (
        <div style={{ padding: '2rem' }}>
            <h1>Dashboard</h1>
            <p>Month: {month}</p>

            <section>
                <h2>Accounts</h2>
                <ul>
                    {accounts.map(account => (
                        <li key={account.id}>
                            {account.name} ({account.type}) — ₱{account.balance}
                        </li>
                    ))}
                </ul>
            </section>

            <section>
                <h2>Summary</h2>
                <p>Inflow: ₱{summary.inflow}</p>
                <p>Expense: ₱{summary.expense}</p>
                <p>Net: ₱{summary.inflow - summary.expense}</p>
            </section>

            <section>
                <h2>Budgets</h2>
                <ul>
                    {budgets.map((item, index) => (
                        <li key={index}>
                            {item.category}: ₱{item.actual} / ₱{item.budget}
                            {item.status === 'over' && ' ⚠️'}
                        </li>
                    ))}
                </ul>
            </section>
        </div>
    );
}

