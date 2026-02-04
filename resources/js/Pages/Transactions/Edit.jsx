import { useForm } from '@inertiajs/react';

export default function Edit({ transaction, accounts, categories }) {
    const { data, setData, put, delete: destroy, processing, errors } = useForm({
        account_id: transaction.account_id,
        category_id: transaction.category_id,
        amount: transaction.amount,
        transaction_date: transaction.transaction_date,
        notes: transaction.notes || '',
    });

    function submit(e) {
        e.preventDefault();
        put(route('transactions.update', transaction.id));
    }

    function remove() {
        if (confirm('Delete this transaction?')) {
            destroy(route('transactions.destroy', transaction.id));
        }
    }

    return (
        <div style={{ padding: '2rem' }}>
            <h1>Edit Transaction</h1>

            <form onSubmit={submit}>
                <select
                    value={data.account_id}
                    onChange={e => setData('account_id', e.target.value)}
                >
                    {accounts.map(a => (
                        <option key={a.id} value={a.id}>{a.name}</option>
                    ))}
                </select>

                <select
                    value={data.category_id}
                    onChange={e => setData('category_id', e.target.value)}
                >
                    {categories.map(c => (
                        <option key={c.id} value={c.id}>{c.name}</option>
                    ))}
                </select>

                <input
                    type="number"
                    step="0.01"
                    value={data.amount}
                    onChange={e => setData('amount', e.target.value)}
                />

                <input
                    type="date"
                    value={data.transaction_date}
                    onChange={e => setData('transaction_date', e.target.value)}
                />

                <textarea
                    value={data.notes}
                    onChange={e => setData('notes', e.target.value)}
                />

                <button disabled={processing}>Update</button>
                <button type="button" onClick={remove}>Delete</button>
            </form>
        </div>
    );
}
